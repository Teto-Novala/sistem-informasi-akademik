export default function Button({ children, ...props }) {
    return (
        <button
            {...props}
            className="border border-white text-white rounded px-3 py-2 hover:bg-white hover:text-sky-500"
        >
            {children}
        </button>
    );
}
