describe('Painel de Controle - Página de listar Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/painel/oportunidades');
    });

    it('Garante que a página de Oportunidades existe', () => {
        cy.get('.management-panel__title').contains('Minhas Oportunidades').should('be.visible');
        cy.get('.management-panel__action').contains('Criar Oportunidade').should('be.visible');
    });
})
