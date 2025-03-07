describe('Teste para Editar Tipo de Espaço', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel');
        cy.get(':nth-child(8) > .nav-link').contains('Tipo de Espaço').click()
    });

    it('Editar um tipo de espaço existente', () => {
        cy.get('tbody > :nth-child(1) > :nth-child(3) > .btn').click();

        cy.get('[data-cy="name"]').should('exist').and('have.value', 'Casa de Show');

        cy.get('[data-cy="name"]').clear()
        cy.get('[data-cy="name"]').type('Anfiteatro');
        cy.get('[type="submit"]').click();

        cy.get('.success.snackbar').contains('O Tipo de Espaço foi atualizado').should('be.visible');

        cy.contains('Anfiteatro').should('be.visible');
    });

    it('Tenta editar com um nome inválido', () => {
        cy.get('tbody > :nth-child(1) > :nth-child(3) > .btn').contains('Editar').click();

        cy.get('[data-cy="name"]').clear()
        cy.get('[data-cy="name"]').type('P');
        cy.get('[type="submit"]').click();

        cy.get('.danger.snackbar').contains('O valor é muito curto. Deveria de ter 2 caracteres ou mais.').should('be.visible');
    });
});
