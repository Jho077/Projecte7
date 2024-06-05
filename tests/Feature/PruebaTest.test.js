import { mount } from '@vue/test-utils';
import Navbar from '@/components/navbar.vue';

describe('Navbar', () => {
  it('should render Navbar component with expected classes', () => {
    const wrapper = mount(Navbar);

    // Verificar que el componente Navbar esté presente
    expect(wrapper.exists()).toBe(true);

    // Verificar que el componente Navbar contenga la clase 'bg-white'
    expect(wrapper.find('nav').classes()).toContain('bg-white');

    // Verificar que el componente Navbar contenga un enlace a la página de inicio
    expect(wrapper.find('a[href="/"]').exists()).toBe(true);

    // Verificar que el componente Navbar contenga un enlace a la página de inicio de sesión
    expect(wrapper.find('a[href="/login"]').exists()).toBe(true);

    // Verificar que el componente Navbar contenga un enlace a la página de registro
    expect(wrapper.find('a[href="/register"]').exists()).toBe(true);

    // Verificar que el componente Navbar contenga un botón para abrir el menú principal
    expect(wrapper.find('button[data-collapse-toggle="navbar-sticky"]').exists()).toBe(true);
  });
});
