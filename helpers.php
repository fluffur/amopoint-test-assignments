<?php

function redirectWithData(string $uri, array $queryData): void
{
    $query = http_build_query($queryData);
    header("Location: $uri?$query");
    exit;
}

function countDigits(string $string): int
{
    preg_match_all('/\d/', $string, $matches);
    return count($matches[0]);
}