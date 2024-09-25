describe('Página de FAQ', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/faq');
    });

    it('Garante que o título da página de FAQ existe', () => {
        cy.get('h1').contains('Está com dúvidas?').should('be.visible');
    });

    it('Garante que o campo de busca está presente e visível', () => {
        cy.get('input.custom-search-input').should('be.visible');
    });

    it('Garante que as sugestões principais estão visíveis', () => {
        cy.get('h5').contains('Principais sugestões').should('be.visible');
        cy.get('h4').contains('Inscrições em editais e oportunidades').should('be.visible');
        cy.get('h4').contains('Cadastro no Mapa').should('be.visible');
    });

    it('Garante que as perguntas frequentes estão visíveis', () => {
        cy.get('p').contains('Inscrições em editais e oportunidades').should('be.visible');
        cy.get('p').contains('Como recuperar meu acesso?').should('be.visible');
        cy.get('p').contains('Cadastro no Mapa').should('be.visible');
    });
});
