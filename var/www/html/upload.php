<?php
$messages = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
    $dir = "files/";
    foreach ($_FILES['files']['name'] as $key => $name) {
        if (empty($name)) continue;
        $tmp_name = $_FILES['files']['tmp_name'][$key];
        $filename = basename($name);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($extension === 'md') {
            if (move_uploaded_file($tmp_name, $dir . $filename)) {
                $messages[] = ['type' => 'success', 'text' => "<strong>$filename</strong> a été envoyé avec succès."];
            }
        } else {
            $messages[] = ['type' => 'danger', 'text' => "<strong>$filename</strong> refusé : Seuls les fichiers .md sont acceptés."];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Importer - MD Manager</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	<div class="container">
		<div class="upload-card">
			<h3 class="mb-4 text-center"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i>Importation</h3>

			<?php foreach ($messages as $msg): ?>
				<div class="alert alert-<?php echo $msg['type']; ?> alert-dismissible fade show" role="alert">
					<?php echo $msg['text']; ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endforeach; ?>

			<form method="POST" enctype="multipart/form-data">
				<div class="mb-4">
					<label for="formFileMultiple" class="form-label">Sélectionnez un ou plusieurs fichiers (.md)</label>
					<input class="form-control" type="file" id="formFileMultiple" name="files[]" accept=".md" multiple required>
				</div>
				<div class="d-grid gap-2">
					<button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Envoyer les fichiers</button>
					<a href="index.php" class="btn btn-link text-secondary text-decoration-none">Retour à l'accueil</a>
				</div>
			</form>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	</body>
</html>
