describe('Painel de Controle - Página de listar Organizações', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('kellymoura@example.com', 'Aurora@2024');
        cy.visit('/painel/organizacoes');
    });

    it('Garante que a página de organizações existe', () => {
        cy.get('h2').contains('Minhas Organizações').should('be.visible');
    });

    it('Garante que as organizações estejam visíveis ', () => {
        cy.get('tbody > tr > :nth-child(1)').contains('De RapEnte').should('be.visible');
        cy.get('tbody >  tr > :nth-child(2)').contains('22/07/2024 16:20:00').should('be.visible');
    });

    it('Garante que seja possível deletar uma organização', () => {
        cy.get('button[data-cy="remove-2"]').click();
        cy.get('[data-modal-button="confirm-link"]').click();

        cy.get('.table').should('not.contain', 'Cultura em ação');
        cy.get('.success.snackbar').contains('A Organização foi excluída').should('be.visible');
    })
})
