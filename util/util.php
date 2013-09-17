<?php
/* Returns the full http path to a resource. For example, if $uri is
 * '/path1/path2/.../path8/path9/path10/file.php?q=908', then the return value
 * will be as follows: if $returned_url == "full-path-query" : full http path
 * to the file with the query string is returned, that is:
 * "https://{$_SERVER['HTTP_HOST']}" . (port if available) .
 * '/path1/path2/.../path8/path9/path10/file.php?q=908', else, if $returned_url
 * == "full-path-no-query" : full http path to the file without the query string
 * is returned, that is: 
 * "https://{$_SERVER['HTTP_HOST']}" . (port if available) .
 * '/path1/path2/.../path8/path9/path10/file.php', else, if $returned_url ==
 * "current-dir" : full http path to the folder in which file is is returned,
 * that is: "https://{$_SERVER['HTTP_HOST']}" . (port if available) .
 * '/path1/path2/.../path8/path9/path10', else, path to the HOME folder of the
 * application is returned, that is, the application root.
 * 
 * @param $uri - This will be the request uri of the page that calls this method
 * @param $returned_url - The string specifying how the returned path should be.
 *                        Must be one of "full-path-query", 
 *                        "full-path-no-query", "current-dir", or "..."; where
 *                        "..." could be any other string.
 * @returns - string - The full http path to a resource as described above. */
function rps_http_path($uri, $returned_url) {
    $scheme = "https";
    $host = $_SERVER['HTTP_HOST'];
    $port = $_SERVER['HTTP_PORT'];
    $url = $scheme . "://" . $host . ($port != "" ? ":" . $port : "") . $uri;
    $path = parse_url($url, PHP_URL_PATH);
    $sub = substr($path, strrpos($path, "/") + 1);
    $current_directory = strrpos($sub, ".") == false ? $path :
        substr($path, 0, strrpos($path, "/"));

    if ($returned_url == "full-path-query") {
        return $url;
    }else if ($returned_url == "full-path-no-query") {
        return
        $scheme . "://" . $host . ($port != "" ? ":" . $port : "") . $path;
    }else if ($returned_url == "current-dir") {
        return $scheme . "://" . $host . ($port != "" ? ":" . $port : "") .
        $current_directory;
    }else { //home ($_home is defined in '../utils.php')
        return
        $scheme . "://" . $host . ($port != "" ? ":" . $port : "");
    }
}
?>
