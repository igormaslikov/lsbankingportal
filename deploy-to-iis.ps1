# deploy-to-iis.ps1
#
# Mirrors the dev working tree (c:\temp\ofsca\loanportal) into the IIS
# physical-path directory (C:\inetpub\wwwroot\lsbankingportal_new\lsbankingportal)
# using robocopy.
#
# Usage:  pwsh .\deploy-to-iis.ps1       # default copy
#         pwsh .\deploy-to-iis.ps1 -DryRun
#
# Excludes:
#   - .git, .claude, .vscode                       (repo tooling)
#   - node_modules                                  (none expected, just in case)
#   - signature_commercial_loan/files/Barcodes/    (per-loan generated PDFs)
#   - signature_*/completed/doc_signs*, doc_initials* (uploaded signature PNGs)
#   - dbconnection.php                             (LIVE credentials — don't overwrite IIS copy)
#   - the recursive jpgraph/Examples/jpgraph/... directory loop
#
# robocopy /MIR mirrors (creates + updates + deletes). To skip deletions of
# files unique to IIS, drop /MIR and use /E.
#
# Exit codes 0–7 are SUCCESS for robocopy; >=8 are real errors.

param(
    [string]$Source = 'c:\temp\ofsca\loanportal',
    [string]$Dest   = 'C:\inetpub\wwwroot\lsbankingportal_new\lsbankingportal',
    [switch]$DryRun
)

if (-not (Test-Path $Source)) {
    Write-Error "Source not found: $Source"; exit 1
}
if (-not (Test-Path $Dest)) {
    Write-Error "Dest not found:   $Dest"; exit 1
}

$flags = @(
    '/E',                    # copy subdirectories incl. empty
    '/R:1', '/W:1',          # 1 retry, 1 sec wait
    '/NDL', '/NP',           # quieter output
    '/XJ',                   # exclude junctions (avoids the jpgraph recursion)
    # Exclude dirs
    '/XD', "$Source\.git",
    '/XD', "$Source\.claude",
    '/XD', "$Source\.vscode",
    '/XD', "$Source\node_modules",
    '/XD', "$Source\signature_commercial_loan\files\Barcodes",
    '/XD', "$Source\signature_commercial_loan\completed\doc_signs",
    '/XD', "$Source\signature_commercial_loan\completed\doc_initials",
    '/XD', "$Source\signature_commercial_loan\completed\doc_signs_coborrow",
    # Exclude files
    '/XF', "$Source\dbconnection.php",
    '/XF', "$Source\*.log"
)

if ($DryRun) {
    $flags += '/L'   # list only, no copy
}

Write-Host "Source: $Source"
Write-Host "Dest:   $Dest"
Write-Host "Mode:   $([if]($DryRun, 'DRY RUN (no changes)', 'COPY'))"
Write-Host ""

& robocopy $Source $Dest @flags

$code = $LASTEXITCODE
if ($code -ge 8) {
    Write-Error "robocopy failed with code $code"
    exit $code
}
Write-Host "`nDone. robocopy exit code = $code (0–7 = success)"
