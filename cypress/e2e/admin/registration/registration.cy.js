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
        cy.get(':nth-child(3) > .resource-card-header > .resource-title').contains("Inscrição para o Concurso de Cordelistas - Festival de Literatura Nordestina").should("be.visible");
        cy.get(':nth-child(3) > .resource-card-body > .resource-details > :nth-child(1)').contains("Fase de recurso").should("be.visible");
        cy.get(':nth-child(3) > .resource-card-body > .resource-details > :nth-child(2)').contains("Fase de recurso do Concurso de Cordelistas").should("be.visible");
        cy.get(':nth-child(3) > .resource-card-body > .resource-details > :nth-child(3)').contains("23/07/2024 até 26/07/2024").should("be.visible");
    });
});
