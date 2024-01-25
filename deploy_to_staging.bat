@echo off

REM Configuration des variables d'environnement
SET "STAGING_DIR=C:\staging"
SET "APP_DIR=C:\Users\kboue\Desktop\Forum"
REM SET "COMPOSER_PATH=C:\chemin\vers\composer.bat"
REM SET "COMPOSER_PATH=C:\laragon\bin\composer"
SET COMPOSER_PATH=C:\ProgramData\ComposerSetup\bin\composer.bat

echo Début du déploiement sur l'environnement de staging...

REM Accédez au répertoire de l'application
cd /d "%APP_DIR%"

REM Assurez-vous que le répertoire de staging existe
IF NOT EXIST "%STAGING_DIR%" MKDIR "%STAGING_DIR%"

REM Copiez les fichiers de l'application vers le répertoire de staging
xcopy /E /Y .\* "%STAGING_DIR%"

REM Accédez au répertoire de staging
cd /d "%STAGING_DIR%"

REM Exécutez les commandes de déploiement supplémentaires
REM Exemple : Installer les dépendances avec Composer
"%COMPOSER_PATH%" install

echo Fin du déploiement sur l'environnement de staging.
