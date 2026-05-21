<?php
/**
 * Minimal SQL Server access layer for the legacy mysqli-style portal code.
 * Requires: Microsoft Drivers for PHP for SQL Server (sqlsrv DLLs in php ext + extension=sqlsrv in php.ini).
 */

final class SqlServerResult
{
	private $stmt;
	/** @var int|false */
	public $num_rows;

	public function __construct($stmt)
	{
		$this->stmt = $stmt;
		if ($stmt !== null && $stmt !== false) {
			$n = sqlsrv_num_rows($stmt);
			$this->num_rows = ($n === false) ? 0 : (int) $n;
		} else {
			$this->num_rows = 0;
		}
	}

	public function fetch_array($result_type = null)
	{
		if ($result_type === null) {
			$result_type = defined('MYSQLI_BOTH') ? MYSQLI_BOTH : 3;
		}
		$mode = SQLSRV_FETCH_BOTH;
		$rt = (int) $result_type;
		if ($rt === 1) {
			$mode = SQLSRV_FETCH_ASSOC;
		}
		if ($rt === 2) {
			$mode = SQLSRV_FETCH_NUMERIC;
		}
		return sqlsrv_fetch_array($this->stmt, $mode);
	}

	public function fetch_assoc()
	{
		return sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC);
	}
}

final class SqlServerDb
{
	/** @var resource|null */
	private $conn;

	public function __construct($conn)
	{
		$this->conn = $conn;
	}

	public function query($sql, $params = [], array $options = [])
	{
		// STATIC cursor supports num_rows and works with aggregates/complex queries.
		// KEYSET fails on aggregate queries (no unique key). Fall back to FORWARD if STATIC also fails.
		$opt = array_merge(['Scrollable' => SQLSRV_CURSOR_STATIC], $options);
		$stmt = sqlsrv_query($this->conn, $sql, $params, $opt);
		if ($stmt === false) {
			$stmt = sqlsrv_query($this->conn, $sql, $params, []);
			if ($stmt === false) {
				$errors = sqlsrv_errors();
				$msg = $errors ? $errors[0]['message'] : 'unknown error';
				error_log("SqlServerDb::query FAILED: $msg | SQL: " . substr($sql, 0, 300));
				return false;
			}
		}
		return new SqlServerResult($stmt);
	}

	public function real_escape_string($s)
	{
		return str_replace("'", "''", (string) $s);
	}

	public function close()
	{
		// Shared singleton connection: do not close here.
	}

	public function insert_id()
	{
		// SQL Server equivalent of mysqli_insert_id / lastInsertId — must be called
		// in the same connection scope as the INSERT that just ran.
		$stmt = sqlsrv_query($this->conn, 'SELECT SCOPE_IDENTITY() AS id', [], ['Scrollable' => SQLSRV_CURSOR_STATIC]);
		if ($stmt === false) {
			return 0;
		}
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		return $row && isset($row['id']) ? (int) $row['id'] : 0;
	}

	public function connect_errno()
	{
		return 0;
	}

	public function connect_error()
	{
		return '';
	}
}

/** @var SqlServerDb|null */
$GLOBALS['PORTAL_SQLSRV_DB'] = null;

function portal_init_sqlsrv_from_dbconnection(): void
{
	if (!function_exists('sqlsrv_connect')) {
		$GLOBALS['PORTAL_SQLSRV_OK'] = false;
		$ini = function_exists('php_ini_loaded_file') ? php_ini_loaded_file() : '';
		$bin = defined('PHP_BINARY') ? PHP_BINARY : '';
		$GLOBALS['PORTAL_SQLSRV_ERR'] =
			"PHP sqlsrv extension is not loaded in THIS PHP (the one handling the web request).\n\n"
			. "If `php -m` in PowerShell shows sqlsrv but the site does not, you are using a different PHP for the web "
			. "(IIS / Apache / Laragon / XAMPP) or a different php.ini than the CLI.\n\n"
			. "Open sqlsrv_check.php in the browser (same host/port) to see which php.ini to edit.\n\n"
			. "Loaded php.ini: " . ($ini ?: '(none)') . "\n"
			. "PHP binary: " . ($bin ?: '(unknown)') . "\n"
			. "SAPI: " . PHP_SAPI . "\n"
			. "Install: https://learn.microsoft.com/sql/connect/php/download-drivers-php-sql-server\n"
			. "Enable in THAT php.ini, e.g. extension=php_sqlsrv_83_ts_x64.dll";
		return;
	}

	global $db_host, $db_name, $db_user, $db_pass, $db_use_windows_auth;
	if (!isset($db_host)) {
		require_once __DIR__ . '/dbconnection.php';
	}

	$server = $db_host ?? '.\\SQLEXPRESS';
	$database = $db_name ?? 'OfscaBank';

	$connectionInfo = [
		'Database' => $database,
		'CharacterSet' => 'UTF-8',
		'ReturnDatesAsStrings' => true,
	];

	$useWin = isset($db_use_windows_auth) ? (bool) $db_use_windows_auth : (($db_user === '' || $db_user === null) && ($db_pass === '' || $db_pass === null));

	if (!$useWin) {
		$connectionInfo['UID'] = (string) $db_user;
		$connectionInfo['PWD'] = (string) $db_pass;
	}

	$conn = sqlsrv_connect($server, $connectionInfo);
	if ($conn === false) {
		$GLOBALS['PORTAL_SQLSRV_OK'] = false;
		$GLOBALS['PORTAL_SQLSRV_ERR'] = print_r(sqlsrv_errors(), true);
		return;
	}

	$GLOBALS['PORTAL_SQLSRV_OK'] = true;
	$GLOBALS['PORTAL_SQLSRV_RES'] = $conn;
	$GLOBALS['PORTAL_SQLSRV_DB'] = new SqlServerDb($conn);
}

function portal_get_sqlsrv_db(): SqlServerDb
{
	if ($GLOBALS['PORTAL_SQLSRV_DB'] === null) {
		portal_init_sqlsrv_from_dbconnection();
	}
	if (empty($GLOBALS['PORTAL_SQLSRV_OK'])) {
		$msg = $GLOBALS['PORTAL_SQLSRV_ERR'] ?? 'SQL Server connection failed.';
		die('<pre>' . htmlspecialchars($msg, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>');
	}
	return $GLOBALS['PORTAL_SQLSRV_DB'];
}

function portal_sqlsrv_errors_string(): string
{
	if (empty($GLOBALS['PORTAL_SQLSRV_ERR'])) {
		return '';
	}
	return (string) $GLOBALS['PORTAL_SQLSRV_ERR'];
}
