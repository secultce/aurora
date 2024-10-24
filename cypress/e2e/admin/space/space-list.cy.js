describe('Painel de Controle - Página de listar Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/painel/espacos');
    });

    it('Garante que a página de Espaços existe', () => {
        cy.get('h2').contains('Meus Espaços').should('be.visible');
    });

    it('Garante que os espaços estejam visíveis ', () => {
        cy.get('tbody > :nth-child(2) > :nth-child(1) > a').contains('Casa da Capoeira').should('be.visible');
        cy.get('tbody > :nth-child(2) > :nth-child(2)').contains('13/08/2024 20:25:00').should('be.visible');
    });
})
