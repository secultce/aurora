describe('Página de Lista de Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/espacos');
    });

    it('Garante que a página de lista de espaços existe', () => {
        cy.get('a.name-one').contains('Início').should('be.visible');
        cy.get('a.name-one').contains('Espaços').should('be.visible');
        cy.get('h2').contains('Espaços').should('be.visible');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
    });

    it('Garante que as opções de ordenar funcionam', () => {
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__title').contains('Dragão do Mar').should('be.visible');
        cy.get('#order-select').select('Mais Recente');
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__title').contains('SECULT').should('be.visible');
    });

    it('Garante que as tabs estão funcionando', () => {
        const tabs = [
            { tab: '#pills-list-tab'},
            { tab: '#pills-map-tab'},
            { tab: '#pills-indicators-tab'}
        ];

        tabs.forEach(({ tab }) => {
            cy.get(tab).click();
            cy.get(tab).should('have.class', 'active');
        });
    });

    it('Garante que os cards de espaços estão visíveis', () => {
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__title').contains('Dragão do Mar').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__type').contains('Complexo Cultural').should('be.visible');
        cy.get('.space-card__info > .mb-md-2').contains('O Dragão do Mar é um dos maiores complexos culturais da região, com teatros, cinemas e galerias de arte que promovem a cultura local e internacional.').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > .justify-content-center > .btn').contains('Acessar espaço').should('be.visible');
    });

    it('Garante que o filtro funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#space-name').type('Dragão do Mar');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Espaços Encontrados').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__title').contains('Dragão do Mar').should('be.visible');
    });

    it('Garante que o botão de limpar filtros funciona', () => {
        cy.get('.align-items-end > .fw-bold').contains('Espaços Encontrados').should('be.visible');
        cy.get('#open-filter').click();
        cy.get('#space-name').type('Dragão do Mar');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Espaços Encontrados').should('be.visible');
        cy.get('#open-filter').click();
        cy.get('.btn-outline-primary').click();
        cy.get('.align-items-end > .fw-bold').contains('Espaços Encontrados').should('be.visible');
    });
});
