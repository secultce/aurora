describe('Página de Minhas Inscrições', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/inscricoes');
    });

    it('Deve verificar a URL da página de Minhas Inscrições', () => {
        cy.url().should('include', '/painel/inscricoes');
        cy.get('h1').contains('Minhas Inscrições');
        cy.get('input[placeholder="Busque por palavras-chave"]').should('exist');
        cy.get('button').contains('Acompanhar').should('exist');
    });
});
