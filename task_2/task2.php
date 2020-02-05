<?php
declare(strict_types=1);

const NEEDLE_VALUE_FOR_DELETE = 3;

$url = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';

$newUrl = rewriteUrl($url);

echo $newUrl . PHP_EOL;

function rewriteUrl(string $string): string
{
    $parseUrl = parse_url($string);

    $query = $parseUrl['query'] ?? null;

    if (empty($query)) {
        throw new RuntimeException('Query is empty');
    }

    $params = [];

    parse_str($query, $params);

    while ($key = array_search(NEEDLE_VALUE_FOR_DELETE, $params)) {
        unset($params[$key]);
    }

    asort($params);

    $path = $parseUrl['path'] ?? null;
    $scheme = $parseUrl['scheme'] ?? null;
    $host = $parseUrl['host'] ?? null;

    if (empty($path) || empty($scheme) || empty($host)) {
        throw new RuntimeException('Path or scheme or host is empty');
    }

    $params['url'] = $path;

    $newQueryString = http_build_query($params);

    $url = sprintf(
        '%s://%s/?%s',
        $scheme,
        $host,
        $newQueryString
    );

    return $url;
}
