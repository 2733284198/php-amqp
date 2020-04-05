<?php
namespace phpamqp;

use DateTimeImmutable;

require_once __DIR__ . '/functions.php';

$nextVersion = $_SERVER['argv'][1];

assert(preg_match(re(VERSION_REGEX), $nextVersion));

gitFetch();
setPackageVersion($nextVersion);
setSourceVersion($nextVersion);
setChangelog(buildChangelog(versionToTag($nextVersion), versionToTag(getPreviousVersion())));
setDate(new DateTimeImmutable('NOW'));
setStability($nextVersion);
updateFiles();
savePackageXml();
validatePackage();
peclPackage(1, $nextVersion);
gitCommit(2, $nextVersion, 'releasing version');
gitTag(3, $nextVersion);