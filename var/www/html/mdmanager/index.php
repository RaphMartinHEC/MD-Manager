<?php
ini_set('display_errors', 0); // On cache les erreurs pour la prod
require_once('Parsedown.php');
$pd = new Parsedown();
$dir = 'files/';
$file = $_GET['file'] ?? null;

if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']);
    $path = $dir . $fileToDelete;
    if (file_exists($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) == 'md') {
        unlink($path);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MD Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-regular fa-file-lines me-2"></i>MD Manager</a>
        <div class="d-flex">
            <a href="upload.php" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Importer</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php if ($file && file_exists($dir . $file)): ?>
        <div class="mb-3">
            <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Retour</a>
        </div>
        <div class="doc-container markdown-body">
            <?php 
            $content = file_get_contents($dir . $file);
            if (function_exists('mb_convert_encoding')) {
                $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
            }
            $content = str_replace("\r\n", "\n", $content);
            echo $pd->text($content); 
            ?>
        </div>

    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Documents</h2>
                    <span class="badge bg-secondary text-white"><?php echo count(glob($dir . "*.[mM][dD]")); ?> fichiers</span>
                </div>

                <div class="list-group shadow-sm">
                    <?php
                    $files = glob($dir . "*.[mM][dD]");
                    if ($files):
                        foreach($files as $f):
                            $realName = basename($f);
                            $displayName = str_replace('_', ' ', pathinfo($realName, PATHINFO_FILENAME));
                    ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="?file=<?php echo urlencode($realName); ?>" class="text-decoration-none text-dark fw-semibold">
                                <i class="fa-regular fa-file-alt text-primary me-2"></i><?php echo htmlspecialchars($displayName); ?>
                            </a>
                            <a href="?delete=<?php echo urlencode($realName); ?>" 
                               class="btn-delete px-2" 
                               onclick="return confirm('Supprimer ce document ?');" 
                               title="Supprimer">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                        <div class="list-group-item text-center py-5 text-muted">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i>
                            Aucun fichier trouvé
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-mysql.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>

</body>
</html>
