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
        cy.get('.space-card').should('have.length.greaterThan', 0);
        cy.get('.space-card__title').should(($titles) => {
            const found = Cypress._.some($titles, (el) => el.innerText.includes('Dragão do Mar'));
            expect(found).to.be.true;
        });

        cy.get('.space-card__type').contains('Complexo Cultural').should('be.visible');
        cy.get('.space-card__info > .mb-md-2').contains('O Dragão do Mar é um dos maiores complexos culturais da região').should('be.visible');
        cy.get('.space-card__info > .justify-content-center > .btn').contains('Acessar espaço').should('be.visible');
    });

    it('Garante que o filtro funciona', () => {
        cy.get('#open-filter').click();
        cy.get('#space-name').type('Dragão do Mar');
        cy.get('#apply-filters').click();
        cy.get('.align-items-end > .fw-bold').contains('1 Espaços Encontrados').should('be.visible');

        cy.get('.space-card__title').should(($titles) => {
            const found = Cypress._.some($titles, (el) => el.innerText.includes('Dragão do Mar'));
            expect(found).to.be.true;
        });
    });

    it('Garante que as opções de ordenar funcionam', () => {
        cy.get('#order-select')
            .should('exist')
            .should('be.visible');
        cy.get('#order-select')
            .select('Mais Recente')
            .should('have.value', 'DESC');
        cy.get('#order-select')
            .select('Mais Antigo')
            .should('have.value', 'ASC');
    });
});
