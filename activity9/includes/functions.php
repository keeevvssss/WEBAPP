<?php

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function filterEmployees(array $employees, string $search): array
{
    $search = strtolower(trim($search));

    if ($search === '') {
        return $employees;
    }

    return array_filter($employees, function (array $employee) use ($search): bool {
        $searchableText = strtolower(implode(' ', [
            $employee['name'],
            $employee['position'],
            $employee['department'],
            $employee['email'],
            $employee['location'],
        ]));

        return strpos($searchableText, $search) !== false;
    });
}

function getInitials(string $name): string
{
    $words = explode(' ', trim($name));
    $initials = '';

    foreach ($words as $word) {
        if ($word !== '') {
            $initials .= strtoupper(substr($word, 0, 1));
        }
    }

    return $initials;
}

function getDepartmentCount(array $employees): int
{
    $departments = array_column($employees, 'department');

    return count(array_unique($departments));
}
