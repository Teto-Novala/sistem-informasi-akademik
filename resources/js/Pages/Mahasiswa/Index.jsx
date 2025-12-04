import { Button } from "@/Components/ui/button";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";
import { Link } from "@inertiajs/react";
import React, { useState } from "react";

export default function Index({ data }) {
    const [dataApi, setDataApi] = useState(data || []);
    const deleteIdHandler = async (id) => {
        try {
            const response = await axios.delete(route("mahasiswa.destroy", id));

            alert(response.data.message);

            setDataApi((prevData) => {
                return prevData.filter((item) => item.id !== id);
            });
        } catch (error) {
            alert(error.message);
        }
    };
    const logoutHandler = () => {};
    return (
        <div className="w-full">
            <h1>Daftar Mahasiswa</h1>
            <div className="flex gap-2">
                {/* Tombol Excel */}
                <Button
                    variant="outline"
                    asChild
                    className="bg-green-600 text-white hover:bg-green-700 hover:text-white"
                >
                    <a
                        href={route("mahasiswa.export.excel")}
                        target="_blank"
                        rel="noreferrer"
                    >
                        Excel
                    </a>
                </Button>

                {/* Tombol PDF */}
                <Button
                    variant="outline"
                    asChild
                    className="bg-red-600 text-white hover:bg-red-700 hover:text-white"
                >
                    <a
                        href={route("mahasiswa.export.pdf")}
                        target="_blank"
                        rel="noreferrer"
                    >
                        PDF
                    </a>
                </Button>

                {/* Tombol Tambah */}
                <Button asChild>
                    <Link href={"/mahasiswa/create"}>Tambah Mahasiswa</Link>
                </Button>
                <Button asChild>
                    <Link href={"/dashboard"}>Kembali</Link>
                </Button>
                <Button onClick={logoutHandler}>Logout</Button>
            </div>
            <Table>
                <TableCaption>Daftar Mahasiswa</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>NIM</TableHead>
                        <TableHead>NAMA</TableHead>
                        <TableHead>JURUSAN</TableHead>
                        <TableHead>AKSI</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {dataApi.map((item, index) => {
                        return (
                            <TableRow key={index}>
                                <TableCell>{item.nim}</TableCell>
                                <TableCell>{item.nama}</TableCell>
                                <TableCell>{item.jurusan}</TableCell>
                                <TableCell className="flex gap-x-4">
                                    <Button asChild>
                                        <Link
                                            href={`/mahasiswa/${item.id}/edit`}
                                        >
                                            Ubah
                                        </Link>
                                    </Button>
                                    <Button
                                        onClick={() => deleteIdHandler(item.id)}
                                    >
                                        Hapus
                                    </Button>
                                </TableCell>
                            </TableRow>
                        );
                    })}
                </TableBody>
            </Table>
        </div>
    );
}
