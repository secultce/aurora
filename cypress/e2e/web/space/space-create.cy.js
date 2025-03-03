describe('Criar um espaço e atualizar o dashboard', () => {
    beforeEach(() => {
        cy.visit('/login');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.url().should('include', '/');
    });

    Cypress.on('uncaught:exception', (err) => {
        if (err.message.includes('i.createPopper is not a function')) {
            console.warn('Erro ignorado do Popper.js:', err.message);
            return false;
        }
    });

    it('Deve criar um espaço e verificar se o número de espaços aumentou', () => {
        cy.visit('/espacos');

        cy.get('.dashboard-card:contains("Registrados nos últimos 7 dias") h2.quantity')
            .invoke('text')
            .then((quantityBefore) => {
                const totalBefore = parseInt(quantityBefore.trim(), 10);

                createNewSpace();

                cy.visit('/espacos');

                cy.get('.dashboard-card:contains("Registrados nos últimos 7 dias") h2.quantity')
                    .invoke('text')
                    .should((quantityAfter) => {
                        const totalAfter = parseInt(quantityAfter.trim(), 10);
                        expect(totalAfter).to.eq(totalBefore + 1);
                    });
            });
    });

    function createNewSpace() {
        cy.contains('button, a', 'Criar espaço').click();
        cy.url().should('include', '/painel/espacos/adicionar');

        cy.get('input#name').type('Espaço de Teste Cypress');
        cy.get('input#maxCapacity').type('100');
        cy.get('input#isAccessible').check();
        cy.get('button[data-cy="submit"]').click();
    }
});
