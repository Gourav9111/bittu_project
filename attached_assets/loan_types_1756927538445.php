<?php
// Debug Mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// DB Connection
$host = "localhost";
$db   = "u900473099_gourav";
$user = "your_db_user";   // change
$pass = "your_db_pass";   // change

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "DB Connection failed: " . $e->getMessage()]);
    exit;
}

// ---------------- GET loan data (for editing) ----------------
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid loan ID']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM loan_types WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $loan = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($loan) {
        echo json_encode(['success' => true, 'loan' => $loan]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Loan type not found']);
    }
    exit;
}

// ---------------- POST: Add / Update / Delete ----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'] ?? '';

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $min_amount = $_POST['min_amount'] ?? null;
        $max_amount = $_POST['max_amount'] ?? null;
        $min_interest_rate = $_POST['min_interest_rate'] ?? null;
        $max_interest_rate = $_POST['max_interest_rate'] ?? null;
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        switch ($action) {
            case 'add':
                // check duplicate
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM loan_types WHERE name = ?");
                $stmt->execute([$name]);
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Loan type already exists.");
                }

                $stmt = $pdo->prepare("INSERT INTO loan_types (name, description, min_amount, max_amount, min_interest_rate, max_interest_rate, is_active) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $min_amount, $max_amount, $min_interest_rate, $max_interest_rate, $is_active]);
                echo json_encode(["success" => true, "message" => "Loan type added successfully"]);
                break;

            case 'update':
                if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                    throw new Exception("Invalid loan ID.");
                }
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM loan_types WHERE name = ? AND id != ?");
                $stmt->execute([$name, $_POST['id']]);
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Loan type with this name already exists.");
                }

                $stmt = $pdo->prepare("UPDATE loan_types 
                                       SET name=?, description=?, min_amount=?, max_amount=?, min_interest_rate=?, max_interest_rate=?, is_active=? 
                                       WHERE id=?");
                $stmt->execute([$name, $description, $min_amount, $max_amount, $min_interest_rate, $max_interest_rate, $is_active, $_POST['id']]);
                echo json_encode(["success" => true, "message" => "Loan type updated successfully"]);
                break;

            case 'delete':
                if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                    throw new Exception("Invalid loan ID.");
                }
                $stmt = $pdo->prepare("DELETE FROM loan_types WHERE id=?");
                $stmt->execute([$_POST['id']]);
                echo json_encode(["success" => true, "message" => "Loan type deleted successfully"]);
                break;

            default:
                throw new Exception("Invalid action.");
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    exit;
}
