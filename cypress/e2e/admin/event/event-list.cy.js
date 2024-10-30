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
        cy.get('tbody > :nth-child(4) > :nth-child(1) > a').contains('Raízes do Sertão').should('be.visible');
        cy.get('tbody > :nth-child(4) > :nth-child(2)').contains('11/08/2024 15:54:00').should('be.visible');
    });
})
