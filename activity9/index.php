<?php

require_once __DIR__ . '/includes/functions.php';
$employees = require __DIR__ . '/data/employees.php';
$search = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';
$filteredEmployees = filterEmployees($employees, $search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Directory</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="index.php"><span class="brand-icon">ACT9</span>Employee Directory</a>
            <span class="topbar-note">Web Application Development</span>
        </div>
    </header>

    <main class="container">
        <section class="intro">
            <div>
                <p class="eyebrow">STAFF AND CONTACTS</p>
                <h1>Employee Directory</h1>
            </div>
            <div class="date-label"><?php echo date('l, F j, Y'); ?></div>
        </section>

        <section class="stats" aria-label="Directory summary">
            <div class="stat-card">
                <div>
                    <p class="stat-label">TOTAL EMPLOYEES</p>
                    <p class="stat-value"><?php echo count($employees); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <p class="stat-label">DEPARTMENTS</p>
                    <p class="stat-value"><?php echo getDepartmentCount($employees); ?></p>
                </div>
            </div>
        </section>

        <section class="directory">
            <div class="directory-heading">
                <div>
                    <h2>All employees</h2>
                    <p>Browse the team directory</p>
                </div>
                <form class="search-form" method="get" action="index.php">
                    <label class="sr-only" for="search">Search employees</label>
                    <input
                        id="search"
                        type="search"
                        name="q"
                        placeholder="Search name, role, department..."
                        value="<?php echo escape($search); ?>"
                    >
                    <button type="submit">Search</button>
                    <?php if ($search !== ''): ?>
                        <a class="clear-link" href="index.php">Clear</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>EMPLOYEE</th>
                            <th>POSITION</th>
                            <th>DEPARTMENT</th>
                            <th>CONTACT</th>
                            <th>LOCATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($filteredEmployees) > 0): ?>
                            <?php foreach ($filteredEmployees as $employee): ?>
                                <tr>
                                    <td>
                                        <div class="employee-cell">
                                            <span class="avatar"><?php echo escape(getInitials($employee['name'])); ?></span>
                                            <div>
                                                <span class="employee-name"><?php echo escape($employee['name']); ?></span>
                                                <span class="employee-id">ID: <?php echo str_pad((string) $employee['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo escape($employee['position']); ?></td>
                                    <td><span class="department-tag"><?php echo escape($employee['department']); ?></span></td>
                                    <td>
                                        <a class="email-link" href="mailto:<?php echo escape($employee['email']); ?>"><?php echo escape($employee['email']); ?></a>
                                        <span class="phone"><?php echo escape($employee['phone']); ?></span>
                                    </td>
                                    <td><?php echo escape($employee['location']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="empty-state" colspan="5">
                                    <strong>No employees found</strong>
                                    <span>Try another name, role, or department.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                Showing <strong><?php echo count($filteredEmployees); ?></strong> of <strong><?php echo count($employees); ?></strong> employees
            </div>
        </section>

    </main>
</body>
</html>
