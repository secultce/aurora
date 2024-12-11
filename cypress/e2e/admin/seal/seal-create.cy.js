describe('Teste de navegação e validação da página de Selos', () => {
    it('Deve acessar a página de Selos a partir de Oportunidades após login', () => {
        cy.visit('/');

        cy.contains('Entrar').click();

        cy.url().should('include', '/login');

        cy.login('saracamilo@example.com', 'Aurora@2024');

        cy.url().should('include', '/');

        cy.contains('Sara Jenifer Camilo').should('be.visible');
        cy.contains('Sara Jenifer Camilo').click();
        cy.contains('Minhas Oportunidades', { timeout: 10000 }).should('be.visible').click();
        cy.url({ timeout: 10000 }).should('include', '/painel/oportunidades');
        cy.scrollTo('bottom');
        cy.contains('Selos', { timeout: 10000 }).should('be.visible').click();
        cy.url({ timeout: 10000 }).should('include', '/painel/selos/');
        cy.get('table', { timeout: 10000 }).should('be.visible');
        cy.contains('Criar', { timeout: 10000 }).should('be.visible').click();
        cy.url({ timeout: 10000 }).should('include', '/painel/selos/adicionar');
    });
});
