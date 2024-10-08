# Makefile para automatizar setup do projeto PHP com Docker

.PHONY: up install_dependencies generate_proxies migrate_database load_fixtures install_frontend compile_frontend generate_keys

# Inicia os serviços Docker em modo detached
up:
	docker compose up -d

# Instala dependências dentro do contêiner PHP
install_dependencies:
	docker compose exec -T php bash -c "composer install"

# Gera os arquivos de Proxies do MongoDB
generate_proxies:
	docker compose exec -T php bash -c "php bin/console doctrine:mongodb:generate:proxies"

# Executa as migrations do banco de dados
migrate_database:
	docker compose exec -T php bash -c "php bin/console doctrine:migrations:migrate -n"

# Executa as fixtures de dados
load_fixtures:
	docker compose exec -T php bash -c "php bin/console doctrine:fixtures:load -n"

# Instala dependências do frontend
install_frontend:
	docker compose exec -T php bash -c "php bin/console importmap:install"

# Compila os arquivos do frontend
compile_frontend:
	docker compose exec -T php bash -c "php bin/console asset-map:compile"

# Gera as chaves de autenticação JWT
generate_keys:
	docker compose exec -T php bash -c "php bin/console lexik:jwt:generate-keypair"

# Comando para rodar todos os passos juntos
setup: up install_dependencies generate_proxies migrate_database load_fixtures install_frontend compile_frontend generate_keys
