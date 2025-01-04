describe('Painel de Controle - Página de listar Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/eventos');
    });

    it('Garante que os eventos estejam visíveis e que é possivel remover um', () => {
        cy.get('h2').contains('Meus Eventos').should('be.visible');

        cy.get('tbody > tr > :nth-child(1)').contains('Nordeste Literário').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains('14/08/2024 10:00:00').should('be.visible');

        cy.get('button[data-cy="remove-2"]').click();
        cy.get('[data-modal-button="confirm-link"]').click();

        cy.get('.table').should('not.contain', 'Músical o vento da Caatinga');
        cy.get('.success.snackbar').contains('O Evento foi excluído').should('be.visible');
    });
})
