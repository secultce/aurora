# Estrutura inicial Mapas Culturais CE

Este repositório fornece uma configuração base de aplicação Symfony com Docker, Nginx e PostgreSQL para o projeto Mapas Culturais CE.

A configuração já está dockerizada, então você só precisa ter o Docker Compose rodando na sua máquina para que tudo funcione corretamente.

## Tecnologias

- **PHP** 8.3
- **PostgreSQL** 13
- **Nginx**
- **Symfony** 7

## Começando

### Clonar o Repositório

Primeiro, clone o repositório usando SSH ou HTTPS:

```bash
git clone git@github.com:TalysonSoares/setup-symfony-docker.git
```
ou
```bash
git clone https://github.com/TalysonSoares/setup-symfony-docker.git
```

### Navegar para o Diretório do Projeto
Mude para o diretório do projeto:

```bash
cd setup-symfony-docker
```

### Iniciar os Contêineres Docker
Execute o Docker Compose para iniciar os contêineres:
```bash
docker-compose up -d
```

## Instalação

### Entrar no Contêiner PHP
Para instalar as dependências do projeto, entre no contêiner PHP:
```bash
docker-compose exec -it secult-php bash
```

### Instalar Dependências
Dentro do contêiner, execute:
```bash
composer install
```

## Uso

Depois que tudo estiver configurado e as dependências instaladas, você pode acessar sua aplicação Symfony em [http://localhost:8080](http://localhost:8080).

Também criei uma rota de teste. Você pode acessá-la em [http://localhost:8080/hello](http://localhost:8080/hello). Esta rota está definida no controller `HelloWorldController` e retorna a mensagem "Bem vind@ ao Mapas Culturais CE".
