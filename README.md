1. docker network create ovolt-project
2. docker compose up -d
3. docker compose exec -it ovolt-php ./bin/console doctrine:migrations:migrate
4. docker compose exec -it ovolt-php php ./bin/console app:products:create