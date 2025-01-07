describe('Painel de Controle - Página de detalhes de uma Oportunidade', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
        cy.visit('/painel/oportunidades/39994097-41d8-463c-a7eb-7d9a0b40e953');
    });

    it('Garante que a página de detalhes de uma oportunidade existe e funciona', () => {
        cy.get('h2').contains('Chamada para Oficinas de Artesanato - Feira de Cultura Popular').should('be.visible');

        cy.get('h3').contains('Inscrições').should('be.visible');

        cy.get('table').contains('Feitozo').should('be.visible');
    });
})
