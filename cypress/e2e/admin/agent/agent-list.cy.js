describe('Página de Listar de Agentes', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/agentes');
    });

    it('Garante que a página de lista de agentes existe', () => {
        cy.get('.breadcrumb-agent > :nth-child(1)').contains('Inicio').should('be.visible');
        cy.get('.breadcrumb-agent > :nth-child(2)').contains('Agentes').should('be.visible');
        cy.get('.agent-dashboard-title').contains('Agentes').should('be.visible');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
    });

    it('Garante que a lista de agentes está presente e os itens são visíveis', () => {
        cy.get('.agent-list').should('be.visible');
        cy.get('.agent-list > :nth-child(2)').first().should('be.visible');
    });
});
