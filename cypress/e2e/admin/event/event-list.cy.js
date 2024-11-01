describe('Painel de Controle - Página de listar Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/eventos');
    });

    it('Garante que a página de Eventos existe', () => {
        cy.get('h2').contains('Meus Eventos').should('be.visible');
    });

    it('Garante que os eventos estejam visíveis ', () => {
        cy.get('tbody > tr > :nth-child(1)').contains('Nordeste Literário').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains('14/08/2024 10:00:00').should('be.visible');
    });

    it('Garante que seja possível deletar um evento', () => {
        cy.get('button[data-cy="remove-2"]').click();
        cy.get('[data-modal-button="confirm-link"]').click();

        cy.get('.table').should('not.contain', 'Cultura em ação');
    });
})
