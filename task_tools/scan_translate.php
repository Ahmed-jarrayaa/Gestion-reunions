<?php
$root = 'C:/Users/Admin/reunion/templates';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$found = [];
foreach ($it as $f) {
    if ($f->getExtension() !== 'php') {
        continue;
    }
    $c = file_get_contents($f->getPathname());
    if (preg_match_all('/__\(\s*["\x27]([^"\x27]+)["\x27]/u', $c, $m)) {
        foreach ($m[1] as $s) {
            $found[] = str_replace($root . '\\', '', $f->getPathname()) . ' :: ' . $s;
        }
    }
}
if (!$found) {
    echo "NO __() STRINGS REMAIN\n";
} else {
    sort($found);
    foreach ($found as $line) {
        echo $line . "\n";
    }
}
