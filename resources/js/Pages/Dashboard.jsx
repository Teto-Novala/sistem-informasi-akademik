import { Button } from "@/Components/ui/button";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";

export default function Dashboard() {
    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div>
                <Button asChild>
                    <Link href={route("dosen.index")}>Dosen</Link>
                </Button>
                <Button asChild>
                    <Link href={route("mahasiswa.index")}>Mahasiswa</Link>
                </Button>
                <Button asChild>
                    <Link href={route("matakuliah.index")}>Mata Kuliah</Link>
                </Button>
                <Button asChild>
                    <Link href={route("nilai.index")}>Nilai</Link>
                </Button>
            </div>
        </AuthenticatedLayout>
    );
}
