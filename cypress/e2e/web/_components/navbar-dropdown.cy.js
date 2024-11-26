describe('Teste de Dropdown do Navbar após Login', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/');
        cy.login('saracamilo@example.com', 'Aurora@2024');
        cy.contains('Sara Jenifer Camilo').should('be.visible');
    });

    it('Verifica a funcionalidade completa do dropdown do navbar', () => {
        const ensureDropdownIsOpen = () => {
            cy.get('#customDropdown').then(($dropdown) => {
                if ($dropdown.css('display') === 'none') {
                    cy.get('#dropdownMenuButton').click();
                    cy.get('#customDropdown').should('be.visible');
                }
            });
        };

        ensureDropdownIsOpen();

        const menuItems = [
            'Painel de Controle',
            'Minhas Oportunidades',
            'Minhas Inscrições',
            'Minhas Avaliações',
            'Meus Agentes',
            'Meus Espaços',
            'Meus Eventos',
            'Minhas Iniciativas',
            'Conta e Privacidade',
            'Meu Perfil',
            'Sair'
        ];

        menuItems.forEach((item) => {
            ensureDropdownIsOpen();
            cy.get('#customDropdown').contains(item).click();
        });
    });
});
