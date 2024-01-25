pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], userRemoteConfigs: [[url: 'https://github.com/CAMPBEL1830/forum.git']]])
            }
        }

        stage('Mise des dépendances composer') {
            steps {
                script {
                    // Mise à jour des dépendances Composer
                    bat 'composer update --no-interaction --no-ansi'
                }
            }
        }

        stage('Test PHP') {
            steps {
                script {
                    // Commandes pour exécuter les tests PHP
                    bat 'vendor\\bin\\phpunit AuthenticatorTest.php --log-junit test-reports/phpunit.xml'
                    // Publication des rapports de tests à Jenkins
                    junit 'test-reports/phpunit.xml'
                }
            }
        }


        stage('Run PHPUnit Tests') {
            steps {
                script {
                    // Commande pour exécuter les tests PHPUnit sous Windows avec Composer
                    bat '.\\vendor\\bin\\phpunit AuthenticatorTest.php'
                }
            }
        }
    //Début des tests de unitaires et de sécurité

        // stage('Tests Unitaires') {
        //     steps {
        //         script {
        //             // Commandes pour exécuter les tests unitaires
        //             bat 'vendor/bin/phpunit'
        //         }
        //     }
        // }
//Création d'un dossier tests a la racine du projet
        stage('Tests d\'Intégration') {
            steps {
                script {
                    // Commandes pour exécuter les tests d'intégration
                    bat 'vendor/bin/phpunit tests/Integration'
                }
            }
        }

        stage('Tests de Sécurité Automatisés') {
            steps {
                script {
                    // Commandes pour exécuter les tests de sécurité automatisés
                    bat '"vendor/bin/phpstan" analyse "C:\\Users\\silue\\OneDrive\\Bureau\\Forum-konate\\analyse"'
                    //installation du phpstan
                }
            }
        }


        // stage('Scanner de Vulnérabilités') {
        //     steps {
        //         script {
        //             // Commandes pour exécuter le scanner de vulnérabilités (OWASP ZAP)
        //             bat 'zap-baseline.py -t http://192.168.243.157'
        //         }
        //     }
        // }

        // stage('Analyse de Code Statique') {
        //     steps {
        //         script {
        //             // Commandes pour exécuter l'analyse de code statique (SonarQube, Scrutinizer, etc.)
        //             bat 'sonar-scanner'
        //         }
        //     }
        // }

        // stage('Intégration Continue de Tests de Sécurité') {
        //     steps {
        //         script {
        //             // Commandes pour exécuter des tests de sécurité continus (PHP Security Checker, etc.)
        //             bat 'php security-checker.phar security:check'
        //         }
        //     }
        // }
// Fin des test
        stage('Build Docker Image') {
            steps {
                script {
                    // Build Docker image using the Dockerfile at the root of the project
                    docker.build("devopsimage:tag")
                }
            }
        }

//ouverture avec mysql
        stage('Pull MySQL Image') {
            steps {
                script {
                    // Tirer l'image MySQL depuis Docker Hub
                    docker.image("mysql:latest").pull()
                }
            }
        }

        //code fonctionnel
        stage('Run MySQL Container') {
            steps {
                script {
                    def mysqlImage = docker.image('mysql:latest')
                    mysqlImage.pull()
                    mysqlImage.run('-p 3306:3306 --name mysql-container -e MYSQL_ROOT_PASSWORD=my-"" -d')
                }
            }
        }
        //fint code fonctionnel
        /*stage('Run MySQL Container') {
            steps {
                script {
                    // Récupérer l'ID du conteneur MySQL
                    def mysqlContainerId = bat(script: 'docker ps -q --filter name=mysql-container', returnStdout: true).trim()

                    // Arrêter le conteneur MySQL s'il est en cours d'exécution
                    if (mysqlContainerId) {
                        bat "docker stop mysql-container"
                    }

                    // Supprimer le conteneur MySQL s'il existe
                    bat """
                    for /f %%i in ('docker ps -aq --filter "name=mysql-container"') do (
                        docker rm %%i
                    )
                    """

                    // Pull et run du nouvel image
                    docker.image('mysql:latest').pull()
                    docker.image('mysql:latest').run("-p 3306:3306 --name mysql-container -e MYSQL_ROOT_PASSWORD=my-secret-pw -d")
                }
            }
        }*/


        stage('Run Docker Container') {
            steps {
                script {
                    // Stopper et supprimer le conteneur Docker s'il est en cours d'exécution
                    bat 'docker stop devops-container 2>nul || exit 0'
                    bat 'docker rm devops-container 2>nul || exit 0'

                    // Lancer le nouveau conteneur Docker
                    bat 'docker run -p 8081:80 -d --link mysql-container:mysql --name devops-container --network reseau_devops devopsimage:tag'
                    //bat 'docker run -p 8081:80 --link mysql-container:mysql --network=reseau_devops -d devopsimage:tag'

                }
            }
        }

        stage('Start XAMPP') {
            steps {
                script {
                    bat 'docker run --name myXampp -p 41061:22 -p 41062:80 -d -v ~/my_web_pages:/www --network reseau_devops tomsik68/xampp'
                }
            }
        }
        
        stage('Access Application') {
            steps {
                script {

                    //bat 'docker run -p 8081:80 -d --name devops-container devopsimage:tag'
                    // Attendez quelques secondes pour permettre au conteneur de démarrer complètement
                    sleep time: 20, unit: 'SECONDS'
                    
                    // Liste les conteneurs Docker en cours d'exécution
                    bat 'docker ps'
                    
                    // Utilise curl pour tester l'accessibilité de votre application
                    bat 'curl http://localhost:8081'

                    // Ouvrir le navigateur avec le port spécifié
                    bat 'start http://localhost:8081'
                }
            }
        }


//fermeture avec mysql

        stage('Deploy to Staging') {
            steps {
                script {
                    // Ajoutez vos commandes de déploiement vers l'environnement de staging ici
                    bat 'deploy_to_staging.bat'
                }
            }
        }

        stage('Deploy to Production') {
            steps {
                script {
                    // Ajoutez vos commandes de déploiement vers l'environnement de production ici
                    bat 'deploy_to_production.bat'
                }
            }
        }
    }

    post {
        always {
            echo 'Cette section sera toujours exécutée'
        }
        success {
            echo 'Le pipeline a réussi!'
        }
        failure {
            echo 'Le pipeline a échoué. Veuillez vérifier les journaux pour plus d\'informations.'
        }
    }
}
