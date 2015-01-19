RewriteRule ^album-(\d+)-(\d+)\.html$ photo.php?do=album&catid=$1&page=$2 last;
RewriteRule ^pic-(\d+)-(\d+)\.html$ photo.php?do=pic&aid=$1&picid=$2 last;

