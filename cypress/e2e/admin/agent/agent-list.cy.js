describe('Página de Listar de Agentes', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/agentes');
    });

    it('Garante que a página de lista de agentes existe', () => {
        cy.get('.breadcrumb-agent > :nth-child(1)').contains('Inicio').should('be.visible');
        cy.get('.breadcrumb-agent > :nth-child(2)').contains('Agentes').should('be.visible');
        cy.get('.entity-dashboard-title').contains('Agentes').should('be.visible');
        cy.contains('Agentes Cadastrados');
        cy.contains('Alice Nogueira');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
    });
});
