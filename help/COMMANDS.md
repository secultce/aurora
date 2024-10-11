# Documentação dos comandos disponíveis no Aurora

O Makefile automatiza várias etapas do processo de configuração e manutenção do Aurora usando Docker. Abaixo estão listados todos os comandos e suas respectivas descrições.

## Comandos disponíveis
<details>
<summary>UP</summary>

### `up`
Inicia os serviços Docker em modo *detached* (em segundo plano).
- **Uso:** `make up`
- **Descrição:** Este comando executa `docker compose up -d`, iniciando todos os contêineres definidos no arquivo `docker-compose.yml` em segundo plano, para que você possa continuar usando o terminal.
</details>

<details>
<summary>DOWN</summary>

### `down`
Para os serviços Docker.
- **Uso:** `make down`
- **Descrição:** Executa `docker compose down`, encerrando todos os contêineres e redes iniciados pelo comando `up`.
</details>

<details>
<summary>INSTALL_DEPENDECIES</summary>

### `install_dependencies`
Instala as dependências PHP dentro do contêiner.
- **Uso:** `make install_dependencies`
- **Descrição:** Executa `composer install` dentro do contêiner PHP, instalando todas as dependências listadas no arquivo `composer.json`.

</details>

<details>
<summary>GENERATE_PROXIES</summary>

### `generate_proxies`
Gera os proxies do MongoDB.
- **Uso:** `make generate_proxies`
- **Descrição:** Executa `php bin/console doctrine:mongodb:generate:proxies`, gerando os arquivos de proxy necessários para a integração com MongoDB no projeto.
</details>

<details>
<summary>MIGRATE_DATABASE</summary>

### `migrate_database`
Executa as migrações do banco de dados.
- **Uso:** `make migrate_database`
- **Descrição:** Executa `php bin/console doctrine:migrations:migrate -n` dentro do contêiner, aplicando todas as migrações pendentes no banco de dados sem pedir confirmação adicional (`-n` significa *no interaction*).
</details>

<details>
<summary>LOAD_FIXTURES</summary>

### `load_fixtures`
Carrega os dados de *fixtures* no banco de dados.
- **Uso:** `make load_fixtures`
- **Descrição:** Executa `php bin/console doctrine:fixtures:load -n`, carregando dados fictícios (fixtures) no banco de dados. Útil para popular o banco com dados de teste.
</details>

<details>
<summary>INSTALL_FRONTEND</summary>

### `install_frontend`
Instala as dependências do frontend.
- **Uso:** `make install_frontend`
- **Descrição:** Executa `php bin/console importmap:install`, instalando as dependências frontend necessárias para o Aurora.
</details>

<details>
<summary>COMPILE_FRONTEND</summary>

### `compile_frontend`
Compila os arquivos do frontend.
- **Uso:** `make compile_frontend`
- **Descrição:** Executa `php bin/console asset-map:compile`, compilando os arquivos frontend (como CSS e JavaScript) para o Aurora.
</details>

<details>
<summary>TESTS_FRONT</summary>

### `tests_front`
Executa as fixtures de dados e os testes de frontend.
- **Uso:** `make tests_front`
- **Descrição:** Carrega os dados de fixtures no banco de dados e depois roda os testes de frontend com Cypress.
</details>

<details>
<summary>TESTS_BACK</summary>

### `tests_back`
Executa as fixtures de dados e os testes de backend.
- **Uso:** `make tests_back`
- **Descrição:** Carrega os dados de fixtures e roda os testes backend usando PHPUnit.
</details>

<details>
<summary>RESET</summary>

### `reset`
Limpa o cache do Aurora.
- **Uso:** `make reset`
- **Descrição:** Executa `php bin/console cache:clear` para limpar o cache gerado pela aplicação.
</details>

<details>
<summary>STYLE</summary>

### `style`
Executa o PHP CS Fixer.
- **Uso:** `make style`
- **Descrição:** Roda `php bin/console app:code-style` dentro do contêiner PHP para garantir que o código segue os padrões de estilo definidos pelo Aurora.
</details>

<details>
<summary>GENERATE_KEYS</summary>

### `generate_keys`
Gera as chaves de autenticação JWT.
- **Uso:** `make generate_keys`
- **Descrição:** Executa `php bin/console lexik:jwt:generate-keypair --overwrite` para gerar ou sobrescrever as chaves usadas para autenticação JWT.
</details>

<details>
<summary>SETUP</summary>

### `setup`
Executa uma sequência de passos de configuração.
- **Uso:** `make setup`
- **Descrição:** Este comando é um *shortcut* para rodar os comandos: `up`, `install_dependencies`, `generate_proxies`, `migrate_database`, `load_fixtures`, `install_frontend`, `compile_frontend`, e `generate_keys` de uma vez só.
</details>

## Instruções de Uso

Para usar qualquer um dos comandos, basta executar no terminal:
```bash
make <nome_do_comando>
