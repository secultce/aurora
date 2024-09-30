# Aurora E2E Tests

Este repositório contém os testes End-to-End (E2E) para a aplicação, integrados ao código principal.

## Pré-requisitos

- **NPM**: Você precisa ter o NPM instalado para gerenciar os pacotes necessários para os testes. Visite [https://www.npmjs.com/get-npm](https://www.npmjs.com/get-npm) para instruções de instalação.
- **Node.js**: O Node.js é necessário para executar o Cypress. Visite [https://nodejs.org/en/download/](https://nodejs.org/en/download/) para instruções de instalação.

## Instalação

1. Entre no diretório em que o repositório do aurora foi clonado:

   ```sh
   cd seu-diretorio/aurora
   ```

2. Instale os pacotes NPM necessários:

   ```sh
   npm install
   ```

## Execução dos Testes

Para executar os testes E2E integrados, utilize o seguinte comando:

```sh
npx cypress open
```

Isso abrirá a interface do Cypress, onde você pode executar os testes interativamente.

## Contribuição

Para contribuir com melhorias ou correções nos testes:

1. Crie um branch com um nome descritivo baseado no tipo de contribuição, por exemplo:

   ```sh
   git checkout -b feature/add-new-test
   ```

   ```sh
   git checkout -b bugfix/login-issue
   ```

   ```sh
   git checkout -b enhancement/refactor-test-code
   ```

2. Faça suas alterações e submeta um Pull Request para este repositório.

## Criando um Teste no Cypress

Para criar um novo teste no Cypress, siga os passos abaixo:

1. Crie um novo arquivo de teste na pasta `cypress/e2e` com a extensão `.cy.js`. Por exemplo, `cypress/e2e/meu-teste.cy.js`.

2. Escreva o teste usando a estrutura básica. Por exemplo:

   ```javascript
   describe('Meu Teste', () => {
     it('Deve fazer algo', () => {
       cy.visit('https://example.cypress.io');
       cy.get('h1').should('contain', 'Kitchen Sink');
     });
   });
   ```
   
3. Execute o teste com o comando `npx cypress open` e selecione o arquivo de teste que você criou.

## Documentação Cypress

Para mais informações sobre como criar e executar testes automatizados com o Cypress, consulte a documentação oficial do Cypress.

Visite a [Documentação oficial do Cypress](https://docs.cypress.io/guides/overview/why-cypress) para mais informações.

Agradecemos pela colaboração e contribuição para manter a qualidade da aplicação!