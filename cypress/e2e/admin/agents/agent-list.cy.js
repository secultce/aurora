describe('Painel de Controle - Página de listar Agentes', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/agentes');
    });

    it('Garante que a página de Agentes existe', () => {
        cy.get('h2').contains('Meus Agentes').should('be.visible');
    });

    it('Garante que os agentes estejam visíveis ', () => {
        cy.get('tbody > tr > :nth-child(1)').contains('Talyson').should('be.visible');
        cy.get('tbody >  tr > :nth-child(2)').contains('22/07/2024 16:20:00').should('be.visible');
    });

    // it('Garante que seja possível deletar um agente', () => {
    //     cy.get('button[data-cy="remove-1"]').click();
    //     cy.get('[data-modal-button="confirm-link"]').click();
    //
    //     cy.get('.table').should('not.contain', 'Agent Name');
    // });
})
