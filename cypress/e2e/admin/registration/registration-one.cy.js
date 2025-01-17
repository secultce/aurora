describe('Página de detalhes da Inscrição', () => {
    it('Deve verificar o caminho até chegar a uma inscrição', () => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/oportunidades');

        cy.get('a').contains('Edital de Patrocínio para Grupos de Maracatu - Carnaval Cultural').click();
        cy.url().should('include', '/painel/oportunidades/d1068a81-c006-4358-8846-a95ef252c881');
        cy.get('.nav-link[data-bs-toggle="pill"]').contains('Inscrições').click();
        cy.get('tbody > :nth-child(1)').contains('Ver Inscrição').click();
        cy.url().should('include', '/painel/inscricoes/89990f84-1629-4ce5-97f5-2b0e8f3251eb');
        cy.contains('Edital de Patrocínio para Grupos de Maracatu - Carnaval Cultural').should("be.visible");
    });
});
