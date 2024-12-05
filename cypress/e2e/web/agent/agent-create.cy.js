describe('Página de Criação de Agente', () => {
    beforeEach(() => {
        cy.visit('/agentes/cadastro');
    });

    it('Deve carregar os campos obrigatórios corretamente', () => {
        cy.get('#agent-name').should('be.visible');
        cy.get('#mini-bio').should('be.visible');
        cy.get('#agent-site').should('be.visible');
    });

    it('Deve validar que os campos obrigatórios não podem estar vazios', () => {
        cy.get('#agent-create-form').submit();
        cy.get('.flex-md-row > .agent-input-form > .fw-bold').contains('Este campo é obrigatório.');
    });

    it('Deve permitir preencher os campos e enviar o formulário', () => {
        cy.get('#agent-name').type('Agente Teste');
        cy.get('#mini-bio').type('Esta é uma mini bio de teste.');
        cy.get('#agent-site').type('https://www.example.com');
        cy.get('#social-name').type('Nome Social Teste');
        cy.get('#full-name').type('Nome Completo Teste');
        cy.get('#cpf').type('123.456.789-09');
        cy.get('#postal-code').type('60000-000');
        cy.get('#street').type('Rua Exemplo');
        cy.get('#number').type('123');
        cy.get('#neighborhood').type('Bairro Teste');
        cy.get('#public-location').check();
        cy.get('#agent-create-form').submit();
    });


});
