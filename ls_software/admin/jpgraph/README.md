# jpgraph

The `home.php` admin dashboard renders charts via [JpGraph 4.4.1](https://jpgraph.net/).
The library is shipped as a tarball (`jpgraph-4.4.1.tar.gz`, one directory up).

## Install (first-time setup on a new clone)

From `ls_software/admin/`:

```
tar -xzf jpgraph-4.4.1.tar.gz
```

That extracts into `jpgraph/` next to this README.

## Why a tarball?

The previously-extracted `jpgraph/` directory on the OFSCA dev box developed a
recursive nested copy (`jpgraph/Examples/jpgraph/Examples/...`) totalling ~164 MB
and ~4500 files. Shipping the canonical archive avoids dragging that mess into
git history. Re-extracting from the tarball produces a clean ~17 MB tree.
