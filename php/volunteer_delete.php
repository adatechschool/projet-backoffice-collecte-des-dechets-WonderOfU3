<?php
    require "config.php";
    try {
        $id = $_GET["id"];
        $delete_volunteer = $pdo->query("
            DELETE FROM benevoles WHERE id=".$id."
        ");
        header("Location: volunteer_list.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
?>
