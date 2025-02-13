describe('Teste para Deletar Tag', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/admin/tags/');
    });

    it('Deletar uma tag', () => {
        cy.get('tbody > :nth-child(1) > :nth-child(2)').contains('Cultura').should('exist');
        cy.get('[data-cy="remove-1"]').click();

        cy.get('.btn-danger').click();

        cy.get('.toast-body').contains('Tag foi excluída').should('be.visible');
        cy.get('.card').contains('Cultura').should('not.exist');
    });
});
