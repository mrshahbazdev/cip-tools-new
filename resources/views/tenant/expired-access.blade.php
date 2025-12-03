<div style="background-color: #fee2e2; border: 1px solid #f87171; padding: 2rem; margin-top: 5rem; max-width: 600px; margin-left: auto; margin-right: auto; border-radius: 0.5rem; text-align: center;">
    <h1 style="color: #b91c1c; font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Access Blocked 🛑</h1>
    <p style="color: #ef4444; font-size: 1.125rem;">Your trial period has ended.</p>
    
    <p style="color: #4b5563; margin-top: 1.5rem;">
        **Please contact your project administrator to regain access.**
    </p>
    
    <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
        @csrf
        <button type="submit" style="display: inline-block; padding: 0.5rem 1rem; background-color: #4f46e5; color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; border: none;">
            Logout
        </button>
    </form>
</div>