describe('Teste de navegação e validação da página de Timeline dos Eventos', () => {
    beforeEach(() => {
        cy.visit('/');
        cy.contains('Entrar').click();
        cy.url().should('include', '/login');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.url().should('include', '/');
        cy.contains('Sara Jenifer Camilo').should('be.visible');
        cy.contains('Sara Jenifer Camilo').click();
        cy.contains('Meus Eventos').should('be.visible').click();
        cy.url().should('include', '/painel/eventos/');
    });

    it('Deve navegar para a Timeline do primeiro evento e validar itens', () => {
        cy.contains('Timeline').first().click();
        cy.url().should('include', '/timeline');
        cy.contains('Evento - Festival da Rapadura - Timeline').should('be.visible');
        cy.get('table').should('be.visible');
        cy.get('table tbody tr').should('have.length.greaterThan', 0);

        cy.get('table tbody tr').each(($row) => {
            cy.wrap($row).within(() => {
                cy.get('td').eq(0).should('not.be.empty');
                cy.get('td').eq(1).should('not.be.empty');
            });
        });
    });
});
