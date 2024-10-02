describe('Página de Cadastro', () => {
    beforeEach(() => {
        cy.visit('/cadastro');
    });

    it('Clica no botão Voltar e verifica redirecionamento para a página inicial', () => {
        cy.contains('a', 'Voltar').click();

        cy.url().should('eq', `${Cypress.config().baseUrl}`);
    });

    it('Verifica se a página de cadastro existe', () => {
        cy.title().should('include', 'Cadastro');

        cy.get('form.form-stepper').should('exist').and('be.visible');

        cy.get('#inputName').should('exist');
        cy.get('#inputBirdDate').should('exist');
        cy.get('#inputCPF').should('exist');
        cy.get('#inputPhone').should('exist');
        cy.get('#inputEmail').should('exist');
        cy.get('#inputPassword').should('exist');
        cy.get('#inputPasswordConfirm').should('exist');
    });

    it('Preenche os inputs e clica em Continuar', () => {
        cy.get('#inputName').type('João da Silva');
        cy.get('#inputBirdDate').type('1990-01-01');
        cy.get('#inputCPF').type('123.456.789-10');
        cy.get('#inputPhone').type('(11) 91234-5678');
        cy.get('#inputEmail').type('joao.silva@exemple.com');
        cy.get('#inputPassword').type('senha123');
        cy.get('#inputPasswordConfirm').type('senha123');

        cy.get('.btn').contains('Continuar').click();

    });
});
