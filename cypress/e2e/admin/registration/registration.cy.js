describe('Página de Minhas Inscrições', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/inscricoes');
    });

    it('Deve verificar a URL da página de Minhas Inscrições', () => {
        cy.url().should('include', '/painel/inscricoes');
    });

    it('Deve verificar a presença do título da página', () => {
        cy.get('h1').contains('Minhas Inscrições');
    });

    it('Deve verificar a presença do campo de busca por palavra-chave', () => {
        cy.get('input[placeholder="Busque por palavras-chave"]').should('exist');
    });

    it('Deve verificar a presença do botão de acompanhamento', () => {
        cy.get('button').contains('Acompanhar').should('exist');
    });
});
