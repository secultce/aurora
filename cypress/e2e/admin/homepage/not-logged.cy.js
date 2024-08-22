describe('Pagina de Home do ambiente web', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/home');
    });

    const entities = [
        'Oportunidades',
        'Eventos',
        'Espaços',
        'Agentes',
        'Projetos'
    ];

    it('Garante que o navbar existe', () => {
        entities.forEach((entity) => {
            cy.get('a').contains(entity).should('be.visible');
        });
        cy.get('a').contains('Entrar').should('be.visible');
    });

    it('Garante que a seção boas vindas e criar cadastro existam', () => {
        cy.get('h1').contains('Boas-vindas, você chegou ao Mapas Culturais').should('be.visible');
        cy.get('a').contains('CADASTRE-SE').should('be.visible');
    });

    it('Garante que os componentes intro-card estão presentes e visíveis', () => {
        entities.forEach((entity) => {
            cy.get('.intro-card').contains(entity).should('be.visible');
        });
    });
});