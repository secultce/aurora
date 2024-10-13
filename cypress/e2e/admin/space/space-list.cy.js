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

    it('Garante que o dropdown de ordenação está visível e funcional', () => {
        cy.get('#sort-options').contains('Mais Recente');
        cy.get('#sort-options').select('Mais Antigo').should('have.value', 'old'); // Change from 'oldest' to 'old'
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
        cy.get(':nth-child(2) > .space-card__content > .justify-content-between > .d-flex > .space-card__type').contains('Tipo do espaço').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > .mb-2').contains('Lorem ipsum dolor sit amet, consectetur adipiscing elit').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > :nth-child(2) > .align-self-center').contains('SCTS – Zona Cívico Administrativa').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > :nth-child(3) > .space-card__areas').contains('Áreas de atuação').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > :nth-child(4) > .align-self-center').contains('Rampa de acesso').should('be.visible');
        cy.get(':nth-child(2) > .space-card__content > .space-card__info > .justify-content-end > .space-card__button').contains('Acessar espaço').should('be.visible');
    });
});
