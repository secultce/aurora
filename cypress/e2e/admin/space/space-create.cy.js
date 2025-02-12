describe('Painel de Controle - Página de listar Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/espacos');
    });

    it('Garante que a página de Espaços existe', () => {
        cy.get('h2').contains('Meus Espaços').should('be.visible');

        cy.contains('Criar').click();

        cy.wait(100);

        cy.get('[data-cy="name"]').type('Espaço teste');
        cy.get('#maxCapacity').type(100);
        cy.get('#isAccessible').click();

        cy.get('[data-cy="submit"]').click();
        cy.wait(100);

        cy.contains('Novo Espaço criado');
        cy.contains('Espaço teste');
    });
});
