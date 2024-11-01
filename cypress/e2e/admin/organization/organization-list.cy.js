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
})
