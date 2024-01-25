@echo off

REM Spécifiez le chemin complet vers le répertoire de déploiement
SET "DEPLOYMENT_DIR=C:\Users\kboue\Desktop\Forum"

echo --- Début du déploiement sur l'environnement de production ---

REM Changez le répertoire de travail vers le répertoire de déploiement
cd /d "%DEPLOYMENT_DIR%"

REM Assurez-vous que le répertoire est un dépôt Git valide
IF NOT EXIST ".git" (
    echo Le répertoire ne contient pas de dépôt Git valide.
    exit /b 1
)

REM Mettez à jour le code depuis votre référentiel
git pull origin konate

REM Installez les dépendances Composer
composer install --no-interaction --no-ansi

REM Exécutez les tests si nécessaire
vendor\bin\phpunit

echo --- Fin du déploiement sur l'environnement de production ---
