import Button from "@/Components/Button";
import { Head, Link } from "@inertiajs/react";

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const loginHandler = () => {
        window.location.href = "/login";
    };
    const registerHandler = () => {
        window.location.href = "/register";
    };
    return (
        <>
            <Head title="Welcome" />
            <div className="flex items-center justify-center pt-36">
                <div className="bg-sky-500 p-5 rounded flex flex-col justify-center gap-y-4">
                    <h1>Sistem Informasi Akademik</h1>
                    <div className="flex items-center justify-between">
                        <Button onClick={loginHandler}>Login</Button>
                        <Button onClick={registerHandler}>Register</Button>
                    </div>
                </div>
            </div>
        </>
    );
}
