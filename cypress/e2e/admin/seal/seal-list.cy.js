describe('Teste de navegação e validação da página de Selos', () => {
    beforeEach( () => {
        cy.viewport(1920,1080);
        cy.login('kellymoura@example.com', 'Aurora@2024');
        cy.visit('/painel/selos');
    } )
    it('Deve acessar a página de Selos a partir de Oportunidades após login', () => {
        cy.url().should('include', '/painel/selos');

        cy.contains('Anna Kelly Moura Balbino').should('be.visible');
        cy.contains('Anna Kelly Moura Balbino').click();

        cy.contains('Minhas Oportunidades', { timeout: 10000 }).should('be.visible').click();

        cy.url({ timeout: 10000 }).should('include', '/painel/oportunidades');

        cy.scrollTo('bottom');

        cy.contains('Selos', { timeout: 10000 }).should('be.visible').click();

        cy.url({ timeout: 10000 }).should('include', '/painel/selos/');

        cy.get('table', { timeout: 10000 }).should('be.visible');
    });

    it('Garante que seja possível deletar um selo', () => {
        cy.get('tr:contains(Sustentabilidade)').contains('Excluir').as('delButton');

        cy.get('@delButton').should('be.visible');

        cy.get('@delButton').click();

        cy.contains('Confirmar').click();

        cy.contains('Sustentabilidade').should('not.exist');

        cy.contains('O selo foi excluído').should('be.visible');
    });
});
