# Sistema de Gestión, Acreditación y Quórum - Congreso Sección 56 del SNTE

Plataforma web desarrollada para automatizar, transparentar y agilizar el proceso de registro, dictaminación, acreditación de delegados y control de quórum en tiempo real para el Congreso de la **Sección 56 del SNTE**[cite: 1].

---

## 🚀 Pilares del Proyecto (Enfoque Funcional e Incremental)

El sistema está diseñado bajo una arquitectura limpia y modular dividida en 4 pilares esenciales:

### 1. Estructura Básica de Datos
* **Regiones:** Catálogo fijo con las 11 regiones de la Sección 56[cite: 1].
* **Delegaciones / C.T.:** Células sindicales asociadas a su respectiva región, con control de delegados permitidos según convocatoria[cite: 1].
* **Presuntos Delegados:** Información general del docente (Nombre, RFC, Teléfono, Correo), archivo adjunto del Acta de Elección (PDF/Imagen), estatus y código QR de verificación[cite: 1].

### 2. Ciclo de Vida del Delegado (Flujo de Estados)
Secuencia de control para la validación estatutaria:
1. **`REGISTRADO`**: Captura inicial de datos y acta de asamblea de base[cite: 1].
2. **`EN REVISIÓN`**: Análisis de validez por parte de la Comisión Dictaminadora[cite: 1].
3. **`ACREDITADO`**: Delegado efectivo aprobado con generación automática de Gafete y Código QR[cite: 1].
4. **`PRESENTE`**: Check-in realizado mediante escaneo de QR en la entrada de la sede del Congreso[cite: 1].
* *Excepción:* **`OBSERVADO / RECHAZADO`** por actas incompletas o falta de quórum en la asamblea delegacional[cite: 1].

### 3. Roles de Usuario
* **Capturista:** Encargado de dar de alta a los presuntos delegados y adjuntar las actas[cite: 1].
* **Dictaminador (Comisión de Credenciales):** Autoriza, observa o rechaza los expedientes y emite credenciales[cite: 1].
* **Operador de Mesa de Entrada:** Escanea códigos QR para el control de asistencia y quórum en tiempo real[cite: 1].

### 4. Dashboard de Quórum
* **Avance por Región:** Monitoreo del porcentaje de delegados acreditados frente al total permitido en las 11 regiones[cite: 1].
* **Termómetro de Quórum:** Conteo en vivo de asistentes en sala (`PRESENTE`) para validar la instalación legal del Congreso[cite: 1].

---

## 🛠️ Stack Tecnológico
* **Backend:** Laravel (PHP)
* **Panel Administrativo:** Filament PHP
* **Interactividad:** Laravel Livewire
* **Diseño Frontend:** Tailwind CSS