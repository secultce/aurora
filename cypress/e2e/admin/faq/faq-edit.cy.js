describe('Teste de navegação, validação e edição da página de Minhas FAQs', () => {
    beforeEach(() => {

        cy.visit('/');
        cy.contains('Entrar').click();
        cy.url().should('include', '/login');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.url().should('include', '/');
        cy.contains('Sara Jenifer Camilo').should('be.visible').click();
        cy.contains('Minhas Oportunidades').should('be.visible').click();
        cy.url().should('include', '/painel/oportunidades');
        cy.scrollTo('bottom');
        cy.contains('FaQ').should('be.visible').click();
        cy.url().should('include', '/painel/faq/');
        cy.contains('Editar').first().click();
        cy.url().should('include', '/editar');

        cy.get('form').invoke('attr', 'novalidate', true);
    });

    it('Deve validar mensagens de erro para valores muito curtos nos campos', () => {
        cy.get('input[name="question"]').clear().type('A');
        cy.get('textarea[name="answer"]').clear().type('B');

        cy.contains('Salvar').click();

        cy.get('.alert.alert-danger')
            .should('be.visible')
            .and('contain.text', 'O valor é muito curto');
    });

    it('Deve editar e salvar uma FAQ com sucesso', () => {
        cy.get('input[name="question"]')
            .clear()
            .type('Pergunta válida de teste');
        cy.get('textarea[name="answer"]')
            .clear()
            .type('Resposta válida de teste.');

        cy.contains('Salvar').click();
        cy.url().should('include', '/painel/faq/');
        cy.contains('Pergunta válida de teste').should('be.visible');
        cy.contains('Resposta válida de teste.').should('be.visible');
    });

    it('Deve visualizar o item editado no final da lista de FAQs', () => {
        cy.get('input[name="question"]')
            .clear()
            .type('Última pergunta Cypress');
        cy.get('textarea[name="answer"]')
            .clear()
            .type('Resposta final Cypress.');

        cy.contains('Salvar').click();
        cy.url().should('include', '/painel/faq/');
        cy.scrollTo('bottom');
        cy.contains('Última pergunta Cypress').should('be.visible');
        cy.contains('Resposta final Cypress.').should('be.visible');
    });
});
