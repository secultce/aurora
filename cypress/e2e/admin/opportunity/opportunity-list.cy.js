describe('Painel de Controle - Página de listar Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/painel/oportunidades');
    });

    it('Garante que a página de Oportunidades existe', () => {
        cy.get('h2').contains('Minhas Oportunidades').should('be.visible');
    });
})
