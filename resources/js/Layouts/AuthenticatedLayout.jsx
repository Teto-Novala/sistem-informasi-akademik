import Button from "@/Components/Button";

export default function AuthenticatedLayout({ children }) {
    return (
        <div>
            <div className="flex bg-sky-500 py-8 px-8 items-center justify-between">
                <div className="text-xl">Sistem Informasi Akademik</div>
                <div>
                    <Button>Logout</Button>
                </div>
            </div>
            {children}
        </div>
    );
}
