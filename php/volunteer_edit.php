<?php
    require "config.php";

    try {
        $id = $_GET["id"];
        echo "<script>console.log('ID: " . $id . "');</script>";
        $get_info_volunteer = $pdo->query("
            SELECT nom, email, role
            FROM benevoles
            WHERE id = ".$id."
        ");
        $volunteer = $get_info_volunteer->fetch(PDO::FETCH_ASSOC);
        if ($volunteer) {
            echo "<script>console.log('Nom, Role: " . $volunteer["nom"] . ',' . $volunteer["role"] ."');</script>";
        } else {
            echo "<script>console.log('No volunteer found with the given ID.');</script>";
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nom = $_POST["nom"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            echo "<script>console.log('Nom, Email, Role: " . $nom . ', ' . $email . ', ' . $role ."');</script>";
        
            $modify_info_volunteer = $pdo->prepare("UPDATE benevoles SET nom = ?, email = ?, role = ? WHERE id = ?");
            $modify_info_volunteer->execute([$nom, $email, $role, $id]);
        
            header("Location: volunteer_list.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>console.log('Erreur de base de données : " . $e->getMessage() . "');</script>";
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="flex h-screen">
    <!-- Dashboard -->
    <div class="bg-cyan-200 text-white w-64 p-6">
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

            <li><a href="collection_list.php" class="flex items-center py-2 px-3 hover:bg-blue-800 rounded-lg"><i class="fas fa-tachometer-alt mr-3"></i> Tableau de bord</a></li>
            <li><a href="volunteer_list.php" class="flex items-center py-2 px-3 hover:bg-blue-800 rounded-lg"><i class="fa-solid fa-list mr-3"></i> Liste des bénévoles</a></li>
            <li>
                <a href="user_add.php" class="flex items-center py-2 px-3 hover:bg-blue-800 rounded-lg">
                    <i class="fas fa-user-plus mr-3"></i> Ajouter un bénévole
                </a>
            </li>
            <li><a href="my_account.php" class="flex items-center py-2 px-3 hover:bg-blue-800 rounded-lg"><i class="fas fa-cogs mr-3"></i> Mon compte</a></li>

        <div class="mt-6">
            <button onclick="logout()" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg shadow-md">
                Déconnexion
            </button>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-4xl font-bold text-blue-900 mb-6">Modifier un.e bénévole</h1>

        <!-- Formulaire -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom :</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($volunteer["nom"]) ?>" required
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email :</label>
                    <input type="text" name="email" value="<?= htmlspecialchars($volunteer["email"]) ?>" required
                           class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rôle :</label>
                    <select name="role" required
                            class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="" disabled selected>Sélectionnez un rôle</option>
                        <option value="participant" <?= $volunteer["role"] == "participant" ? "selected" : "" ?> >Participant</option>
                        <option value="admin" <?= $volunteer["role"] == "admin" ? "selected" : "" ?> >Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="volunteer_list.php" class="bg-gray-500 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">Annuler</a>
                    <button type="submit" name="save" class="bg-green-300 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
